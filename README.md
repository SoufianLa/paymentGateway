# Payment Gateway

## Overview

This Payment Gateway application is designed to act as an adapter to various external gateway connectors. Currently, it supports ACI, Shift4, and Sandbox (for testing). The application is capable of handling multiple connectors and can be accessed via both web API and CLI.

## Technical Stack

- **Symfony**: v6.4
- **PHP**: v8
- **Docker**: OrbStack

## Getting Started

1. **Clone the application**:
   ```
     git clone https://github.com/SoufianLa/paymentGateway.git
   ```

2. **Installation**:

    - Using Docker:
      ```
       docker-compose -f compose.yaml up -d --build
       docker-compose exec php composer install
       ```

    - Using Symfony CLI:
      ```
       composer install
       symfony server:start
       ```

3. **Test the application**:
   ```
     docker-compose exec php bin/phpunit
     ```

4. **Start Using the application**:
    - For web API Testing:
        - Go to the `request` folder in the project to find all requests. You can test them directly if you have an HTTP plugin installed in your editor.
    - For CLI Testing:
        - Using Docker:
          ```
          docker-compose exec php php bin/console app:gateway [shift4|aci|sandbox]
          ```
        - Without Docker:
          ```
          php bin/console app:gateway [shift4|aci|sandbox]
          ```

