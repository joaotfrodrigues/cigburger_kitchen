<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{
    private $api_url;
    private $project_id;
    private $api_key;

    /**
     * Constructs a new instance of the ApiModel class.
     * 
     * This constructor initializes the ApiModel object by retrieving configuration
     * data from the session. The configuration data includes the API URL, project ID,
     * and API key, which are necessary for interacting with the CigBurger API.
     * 
     * @return void
     */
    public function __construct()
    {
        // load config data from session
        $this->api_url = session()->get('api_url');
        $this->project_id = session()->get('project_id');
        $this->api_key = session()->get('api_key');
    }

    /**
     * Retrieves the status from the CigBurger API.
     * 
     * This function sends a request to the 'get_status' endpoint of the CigBurger API
     * to retrieve the status information. It returns the decoded JSON response from
     * the API, containing the status details.
     * 
     * @return array|null The decoded JSON response from the CigBurger API, or null if an error occurs.
     */
    public function get_status()
    {
        return $this->api('get_status');
    }

    /**
     * Retrieves restaurant details from the CigBurger API.
     * 
     * This function sends a request to the 'get_restaurant_details' endpoint of the
     * CigBurger API to retrieve detailed information about the restaurant. It returns
     * the decoded JSON response from the API, containing the restaurant details.
     * 
     * @return array|null The decoded JSON response from the CigBurger API, or null if an error occurs.
     */
    public function get_restaurant_details()
    {
        return $this->api('get_restaurant_details');
    }

    /**
     * Retrieves pending orders for the current project.
     * 
     * This function sends a request to the 'get_pending_orders' endpoint to retrieve
     * a list of orders that are currently pending for the specified project. It utilizes
     * the `api` method to handle the request and response processing.
     * 
     * @return array|null The decoded JSON response from the CigBurger API, or null if an error occurs.
     */
    public function get_pending_orders()
    {
        return $this->api('get_pending_orders');
    }

    /**
     * Fetches detailed information about an order via an API request.
     * 
     * This function sends a POST request to the 'get_order_details' endpoint with the order ID
     * to retrieve detailed information about the specified order. It utilizes the `api` method 
     * to perform the request and return the response.
     * 
     * @param int $id The ID of the order to retrieve details for.
     * 
     * @return mixed The API response containing the order details.
     */
    public function get_order_details($id)
    {
        return $this->api('get_order_details', 'POST', ['id' => $id]);
    }

    /**
     * Deletes an order by sending a request to the API.
     *
     * This method sends a POST request to the 'delete_order' endpoint of the API to delete the order
     * with the specified ID. It includes the order ID in the request parameters. It returns the response
     * from the API, indicating the success or failure of the deletion operation.
     *
     * @param int $id The ID of the order to delete.
     * @return array The response from the API, containing the status and message of the deletion operation.
     */
    public function delete_order($id)
    {
        return $this->api('delete_order', 'POST', ['id' => $id]);
    }

    /**
     * Retrieves detailed order information including products from the API.
     *
     * This method sends a POST request to the 'get_order_details_with_products' endpoint of the API
     * to retrieve detailed information about an order, including its associated products. It includes
     * the order ID in the request parameters. It returns the response from the API, containing the
     * detailed order information if successful.
     *
     * @param int $id The ID of the order to retrieve details for.
     * @return array The response from the API, containing the detailed order information.
     */
    public function get_order_details_with_products($id)
    {
        return $this->api('get_order_details_with_products', 'POST', ['id' => $id]);
    }

    /**
     * Sends a request to finalize an order by ID through the API.
     * 
     * This function calls the `api` method with the endpoint 'finish_order' and sends a POST request 
     * with the specified order ID. It handles the response from the API to finalize the order, 
     * which includes processing product availability and updating the order status.
     * 
     * @param int $id The ID of the order to be finalized.
     * 
     * @return mixed The response from the API, indicating the status of the operation and any relevant data or messages.
     */
    public function finish_order($id)
    {
        return $this->api('finish_order', 'POST', ['id' => $id]);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // PRIVATE METHODS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Makes a request to the CigBurger API endpoint.
     * 
     * This function sends a request to the specified endpoint of the CigBurger API
     * using the provided HTTP method and data payload. It handles the request using cURL
     * and returns the response from the CigBurger API. If an error occurs during the request,
     * it returns null.
     * 
     * @param string $endpoint The specific endpoint of the CigBurger API to send the request to.
     * @param string $method The HTTP method to use for the request (GET, POST, etc.). Default is 'GET'.
     * @param array $data An associative array of data to send with the request. Default is an empty array.
     * 
     * @return array|null The decoded JSON response from the CigBurger API, or null if an error occurs.
     */
    private function api($endpoint, $method = 'GET', $data = [])
    {
        $curl = curl_init();

        // set the complete url for the api request
        $endpoint = $this->api_url . $endpoint;

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-API-CREDENTIALS: " . $this->_set_credentials()
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return null;
        } else {
            return json_decode($response, true) ?? null;
        }
    }

    /**
     * Generates encrypted credentials for authentication with the CigBurger API.
     * 
     * This function generates encrypted credentials using the project ID and API key
     * provided by the CigBurger API. The credentials are encrypted using the Encrypter
     * service provided by CodeIgniter and returned as a hexadecimal string.
     * 
     * @return string The hexadecimal string representing the encrypted credentials.
     */
    private function _set_credentials()
    {
        $data = json_encode([
            'project_id' => $this->project_id,
            'api_key' => $this->api_key
        ]);

        $encrypter = \Config\Services::encrypter();

        return bin2hex($encrypter->encrypt($data));
    }
}
