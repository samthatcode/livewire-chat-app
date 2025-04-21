# Livewire Chat App

### It's WIP but already usable

## Getting Started 🚀

These instructions will guide you through setting up the project on your local machine for development and testing.

### Prerequisites

You need to have installed the following software:

- PHP 8.3
- Composer 2.0.8
- Node 20.10.0

### Installing

Follow these steps to set up a development environment:

1. **Clone the repository**

    ```bash
    git clone https://github.com/mrpunyapal/livewire-chat-app.git
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

    ```bash
    npm install
    ```

3. **Duplicate the .env.example file and rename it to .env**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**

    ```bash
    php artisan key:generate
    ```

5. **Run migration and seed**

    ```bash
    php artisan migrate --seed
    ```

6. **Run the application**

    ```bash
    npm run dev
    ```

    ```bash
    php artisan serve
    ```

## How to Test the Application 🧪

- Copy .env.testing.example to .env.testing
- Run the following commands

    ```bash
    php artisan key:generate --env=testing
    ```

    ```bash
    npm install && npm run build
    ```

    ```bash
    # Lint the code using Pint
    composer lint
    composer test:lint

    # Refactor the code using Rector
    composer refactor
    composer test:refactor

    # Run PHPStan
    composer test:types

    # Run type coverage
    composer test:type-coverage

    # Run the test suite
    composer test:unit

    # Run all the tests
    composer test
    ```
Check [composer.json](/composer.json#L57-L71) for more details on scripts.

### Give Feedback 💬

Give your feedback on [@MrPunyapal](https://x.com/MrPunyapal)

### Contribute 🤝

Contribute if you have any ideas to improve this project.
