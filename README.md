## Prerequisites

Before you begin, ensure that you have the following installed on your system:

- [PHP](https://www.php.net/) (>= 7.4)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (>= 12.x)
- [npm](https://www.npmjs.com/) (or [Yarn](https://yarnpkg.com/))
- [MySQL](https://www.mysql.com/)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/DavideCoppolaMarbill/email-mkt-tool.git
    ```

2. Navigate to the project directory:

    ```bash
    cd email-mkt-tool
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Install JavaScript dependencies:

    ```bash
    npm install
    # or if using Yarn
    # yarn
    ```

5. Copy the `.env.example` file to `.env` and configure your environment variables, especially the database connection details.

    ```bash
    cp .env.example .env
    ```

6. Generate the application key:

    ```bash
    php artisan key:generate
    ```

7. Run the database migrations:

    ```bash
    php artisan migrate
    ```

8. Start the queue worker for running jobs:

    ```bash
    php artisan queue:work
    ```

## Running the Application

To start your Laravel development server, run:

```bash
php artisan serve
