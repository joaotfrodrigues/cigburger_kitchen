# CigBurger Kitchen Project

## 📋 Table of Contents
- [❓ What is this?](#-what-is-this)
- [🚀 Prerequisites](#-prerequisites)
- [🛠️ Setup](#️-setup)
- [⚙️ Important Configuration](#important-configuration)

## ❓ What is this?

⚠️ Warning: This repository contains only a third of the course project. For the complete project, please check out CigBurger Backoffice and CigBurger Request in my profile.

This is my version of the CigBurger Kitchen project built in the course "[2024] CodeIgniter 4 - 3 large PROFESSIONAL projects united by APIs | MVC | PHP8 | MySQL | All about one structure!"

## 🚀 Prerequisites
Before setting up the project, ensure you have the following installed:
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Git

## 🛠️ Setup

⚠️ **Warning:** The database structure used in this project is created by the CigBurger Backoffice project. Ensure that you have the CigBurger Backoffice set up and the database initialized before running this project.

⚠️ **Important:** You need to download the configuration file from the API tab in CigBurger Backoffice and update the current `config.json` in both the CigBurger Request and CigBurger Kitchen projects. Failure to do so will result in the API not working and the application showing an error.

To set up the project, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/joaotfrodrigues/cigburger_kitchen.git
2. **Navigate to the Project Directory:**
    ```bash
    cd cigburger_kitchen
3. **Install Dependencies:**
    ```bash
    composer install
4. **Configure Environment Variables:**
    - Edit the `.env` file in the project root. If it does not exist, create it.
    - Modify or add the following configuration setting:
        ```dotenv
        CI_ENVIRONMENT=development
        ```
      The `CI_ENVIRONMENT` variable can be set to either `development` or `production` depending on your needs.
    - Update the `APP_BASEURL` variable in the `.env` file to reflect the correct base URL for the application.
5. **Update Configuration File:**
    - Download the `config.json` file from the API tab in CigBurger Backoffice.
    - Replace the current `config.json` file in the CigBurger Kitchen project directory with the downloaded `config.json`.
6. **Start the Development Server:**
    ```bash
    php spark serve
7. **Access the Application:**
    - Open your web browser and go to http://localhost/cigburger_kitchen/public/

## ⚙️ Important Configuration<a name="important-configuration"></a>
To set up the project's important configurations, follow these steps:

1. **Update `config.json` for API URL:**
    - Open the `config.json` file located in the project's root directory.
    - Modify the `api_url` value to include the `/api` endpoint from your CigBurger Backoffice.
        ```json
        {
            "api_url": "http://localhost/cigburger_backoffice/public/api/",
            "project_id": "100",
            "api_key": "j3fEehdw0puDbVJeNK8VMXtgJhibg0jO",
            "machine_id": "XDFFGFRT"
        }
        ```
    - Replace `"http://localhost/cigburger_backoffice/public/api/"` with the actual URL of your CigBurger Backoffice API endpoint.

By following these steps, you should have your CigBurger Kitchen project set up and ready to use. Make sure to check out the other parts of the project, CigBurger Backoffice and CigBurger Request, to complete the full course project.