<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiModel;
use CodeIgniter\HTTP\ResponseInterface;
use MO;

class Main extends BaseController
{
    public function index()
    {
        // initialize system if not initialized
        if (!session()->get('restaurant_details')) {
            $this->_init_system();
        }

        // get pending orders
        $orders = $this->_get_pending_orders();

        // temp - reduce array to x elements (5)
        // $orders = array_slice($orders, 0, 1);

        // load view
        $data['orders'] = $orders;
        return view('main', [
            'orders' => $orders
        ]);
    }

    /**
     * Displays an error message in the view and terminates the application.
     * 
     * This function is responsible for displaying error messages in the view and
     * terminating the application's execution. If a specific error message is provided
     * as an argument, it will be displayed. Otherwise, it attempts to retrieve an error
     * message from the session flash data. If no error message is found, a generic
     * "System error" message is displayed, prompting the user to contact support.
     * 
     * @param string|null $message An optional error message to be displayed. If not provided,
     *                              the function attempts to retrieve an error message from the
     *                              session flash data.
     * 
     * @return View The view containing the error message.
     */
    public function init_error($message = null)
    {
        if (empty($message)) {
            $message = session()->getFlashdata('error');
        }

        if (empty($message)) {
            die('System error: Please contact the support');
        }

        echo view('errors/init_error', [
            'error_message' => $message
        ]);
        die;
    }

    /**
     * Handles the deletion of an order.
     * 
     * This function decrypts the provided encrypted order ID and validates it. If the ID is invalid,
     * it redirects to the home page. It then retrieves the order details by its ID and checks if the 
     * retrieval was successful. If unsuccessful, it redirects to the home page. If the order exists 
     * and is retrieved successfully, it displays a confirmation page with the order details.
     * 
     * @param string $enc_id The encrypted ID of the order to delete.
     * 
     * @return View The redirection or the rendered view of the delete order confirmation page.
     */
    public function delete_order($enc_id)
    {
        // check if $enc_ic is valid
        $id = Decrypt($enc_id);
        if (empty($id)) {
            return redirect()->to('/');
        }

        // get order details
        $model = new ApiModel();

        $order = $model->get_order_details($id);

        if ($order['status'] !== 200) {
            return redirect()->to('/');
        }

        // display confirmation page
        return view('delete_order', [
            'order' => $order['data']
        ]);
    }

    /**
     * Confirms and executes the deletion of an order.
     * 
     * This function decrypts the provided encrypted order ID and validates it. If the ID is invalid,
     * it redirects to the home page. Otherwise, it sends a request to the API to delete the order with
     * the specified ID. After deletion, it redirects to the home page.
     * 
     * @param string $enc_id The encrypted ID of the order to be deleted.
     * 
     * @return RedirectResponse A redirect response to the home page after the order deletion process.
     */
    public function delete_order_confirm($enc_id)
    {
        // check if $enc_ic is valid
        $id = Decrypt($enc_id);
        if (empty($id)) {
            return redirect()->to('/');
        }

        // get order details
        $model = new ApiModel();
        $result = $model->delete_order($id);

        return redirect()->to('/');
    }

    /**
     * Handles an order by retrieving its details along with associated products.
     *
     * This method decrypts the provided encrypted order ID and validates it. If the ID is valid,
     * it retrieves the order details along with associated products using the 'get_order_details_with_products'
     * method of the ApiModel class. If successful, it displays the order handling page, passing
     * the order details and associated products data to the view. If there's an error, it redirects
     * to the home page.
     *
     * @param string $enc_id The encrypted order ID.
     * @return View|Redirect The view for handling the order or a redirect to the home page.
     */
    public function handle_order($enc_id)
    {
        // check if $enc_ic is valid
        $id = Decrypt($enc_id);
        if (empty($id)) {
            return redirect()->to('/');
        }

        // get order details
        $model = new ApiModel();
        $order = $model->get_order_details_with_products($id);

        if ($order['status'] !== 200) {
            return redirect()->to('/');
        }

        // display handle order page
        return view('handle_order', [
            'order_details' => $order['data']['order_details'],
            'order_products' => $order['data']['order_products']
        ]);
    }

    public function handle_order_confirm($enc_id)
    {
        // check if $enc_ic is valid
        $id = Decrypt($enc_id);
        if (empty($id)) {
            return redirect()->to('/');
        }

        // update order status to "finished"
        $model = new ApiModel();
        $result = $model->finish_order($id);

        // check if the result is ok
        if ($result['status'] !== 200) {
            return view('errors/error', [
                'error' => $result['message']
            ]);
        }

        return redirect()->to('/');
    }

    // -----------------------------------------------------------------------------------------------------------------
    // PRIVATE METHODS
    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Initialize the application by loading configuration settings, validating them,
     * and preparing the application for use.
     * 
     * This function loads configuration settings from a JSON file, validates
     * those settings to ensure they are complete and in the correct format, and then
     * prepares the application for use based on the configuration. If any errors
     * occur during the initialization process, an exception is thrown.
     * 
     * @throws Exception If the config file does not exist, has invalid/missing variables,
     *                   or if there are other errors during initialization.
     * 
     * @return void
     * 
     */
    private function _init_system()
    {
        try {
            // check if config file exists
            if (!file_exists(ROOTPATH . 'config.json')) {
                $this->init_error('Config file not found');
            }

            // load config file
            $config = json_decode(file_get_contents(ROOTPATH . 'config.json'), true);

            if (empty($config)) {
                $this->init_error('There was an error loading the config file');
            }

            // check if config file is valid
            if (!key_exists('api_url', $config)) {
                $this->init_error('Config file is not valid: api_url is missing');
            }

            if (!key_exists('project_id', $config)) {
                $this->init_error('Config file is not valid: project_id is missing');
            }

            if (!key_exists('api_key', $config)) {
                $this->init_error('Config file is not valid: api_key is missing');
            }

            if (!key_exists('machine_id', $config)) {
                $this->init_error('Config file is not valid: machine_id is missing');
            }

            // check if api url is valid
            if (!filter_var($config['api_url'], FILTER_VALIDATE_URL)) {
                $this->init_error('Config file is not valid: api_url is not a valid url');
            }

            // check if project id is valid
            if (!is_numeric($config['project_id'])) {
                $this->init_error('Config file is not valid: project_id is not a valid number');
            }

            // check if api key is valid
            if (!preg_match('/^[a-zA-Z0-9]{32}$/', $config['api_key'])) {
                $this->init_error('Config file is not valid: api_key is not a valid key');
            }
        } catch (\Exception $e) {
            $this->init_error('The was an error loading the config file');
        }

        // if everything is ok, set config variables in session
        session()->set($config);

        // get restaurant details
        $this->_get_restaurant_details();
    }

    /**
     * Retrieves restaurant details from the CigBurger API and sets them in the session.
     * 
     * This function loads initial data by fetching restaurant details from theCigBurger
     * API using an instance of the ApiModel class. It then checks the retrieved data
     * to ensure it is valid. If the data is invalid, it displays an error message
     * and terminates the application. Otherwise, it sets the retrieved data in the
     * session for later use.
     * 
     * @return void
     */
    private function _get_restaurant_details()
    {
        // load initial data
        $api = new ApiModel();
        $data = $api->get_restaurant_details();

        // check if data is valid
        if ($data['status'] !== 200) {
            $this->init_error($data['message']);
        }

        if (!$this->_check_data($data)) {
            $this->init_error('System error: Please contact the support');
        }

        // set initial data in session
        $restaurant_data = [
            'restaurant_details' => $data['data']['restaurant_details'],
            'products_categories' => $data['data']['products_categories'],
            'products' => $data['data']['products'],
        ];
        session()->set($restaurant_data);
    }

    /**
     * Checks the validity of retrieved data from an API.
     * 
     * This function verifies whether the retrieved data from an API is valid. It checks
     * if the data is not empty, is an array, contains required keys ('status' and 'message'),
     * and if the 'status' is 200 and the 'message' is 'success'. If any of these conditions
     * are not met, the function returns false indicating invalid data; otherwise, it returns true.
     * 
     * @param array $data The data retrieved from the API.
     * 
     * @return bool True if the data is valid; otherwise, false.
     */
    private function _check_data($data)
    {
        if (
            empty($data)
            || !is_array($data)
            || !key_exists('status', $data)
            || !key_exists('message', $data)
            || $data['status'] !== 200
            || $data['message'] !== 'success'
        ) {
            return false;
        }
        return true;
    }

    /**
     * Retrieves pending orders from the API.
     * 
     * This function sends a request to the `get_pending_orders` endpoint through the `ApiModel`
     * to fetch the list of pending orders for the current project. If the API response status is
     * not 200, it initializes an error with the received message. On success, it returns the 
     * data containing the pending orders.
     * 
     * @return array|null The list of pending orders, or null if an error occurs.
     */
    private function _get_pending_orders()
    {
        $api = new ApiModel();

        $results = $api->get_pending_orders();
        if ($results['status'] !== 200) {
            $this->init_error($results['message']);
        }

        return $results['data'];
    }
}
