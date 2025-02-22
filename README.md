# Sellers Service
RESTful API designed to handle custom sales data from a high-value customer operating across multiple EU countries. This module processes CSV files containing sales representatives' contacts and sales records, storing them in a structured database and exposing the data via API.

- Handles CSV files with hundreds to tens of thousands of records 
- Automated data processing upon file upload
- Categorized data: Seller, Contact, and Sale
- REST API for easy data retrieval

## Tech Stack
- Laravel 9
- PHP 8.1
- MySQL 8
- Redis
- Docker
- PHPUnit

## RequirementsQQQQQ
- [docker-compose](https://docs.docker.com/compose/install/)
- [PHP](https://www.php.net/manual/en/install.php)

## Installation
Run the following command from the terminal:
```
./deploy.sh
```

## Usage
- POST `/load`: Upload a CSV file
- GET `/sellers/{id}`: Provide complete seller data via id
- GET `/sellers/{id}/contacts`: Provide a list of all contacts established by the seller.
- GET `/sellers/{id}/sales`: Provide a list of all sales data accomplished by the seller.
- GET `/sales/{year}`: Provide an object with two properties: stats (netAmount, grossAmount, taxAmount, profit, % profit) and sales (list of the all sales matching the period).

## Execute background jobs
```
php artisan queue:work --tries=3
```

## Run tests
```
composer test
```
## Run coding style tools
```
composer cs
```

## Preview

#### Load CSV file
![app preview](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/images/load.png)

Sample csv files: [2_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_2_records.csv), [1000_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_1000_records.csv), [5000_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_5000_records.csv), [10000_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_10000_records.csv), [50000_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_50000_records.csv), [100000_records.csv](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/csv/myFile_100000_records.csv)

#### Get seller by ID
![app preview](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/images/seller.png)

#### Get seller contacts
![app preview](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/images/contacts.png)

#### Get seller sales
![app preview](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/images/sales.png)

#### Get year stats
![app preview](https://raw.githubusercontent.com/freelancerwebro/sellers-service/main/resources/images/stats.png)