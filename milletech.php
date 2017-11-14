<?php

$ch = curl_init("https://www.milletech.se/invoicing/export/customers");
$fp = fopen("customers.json", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);
$json = json_decode(file_get_contents("customers.json"), true);

$host = 'localhost';
$db = 'curl';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false  ];

$pdo = new PDO($dsn, $user, $password, $options);

foreach ($json as $customer) {
    var_dump($customer);

    $sql = "INSERT INTO `customers` 
            (`id`,`email`, `firstname`, `lastname`, `gender`, `customer_activated`, `group_id`, `customer_company`, `default_billing`, `default_shipping`, `is_active`, `created_at`, `updated_at`, `customer_invoice_email`, `customer_extra_text`, `customer_due_date_period`) 
    VALUES (:id, :email, :firstname, :lastname, :gender, :customer_activated, :group_id, :customer_company, :default_billing, :default_shipping, :is_active, :created_at, :updated_at, :customer_invoice_email, :customer_extra_text, :customer_due_date_period)";
    $stm_insert = $pdo->prepare($sql);
    $stm_insert->execute([
        'id' => $customer['id'],
        'email' => $customer['email'],
        'firstname' => $customer['firstname'],
        'lastname' => $customer['lastname'],
        'gender' => $customer['gender'],
        'customer_activated' => $customer['customer_activated'],
        'group_id' => $customer['group_id'],
        'customer_company' => $customer['customer_company'],
        'default_billing' => $customer['default_billing'],
        'default_shipping' => $customer['default_shipping'],
        'is_active' => $customer['is_active'],
        'created_at' => $customer['created_at'],
        'updated_at' => $customer['updated_at'],
        'customer_invoice_email' => $customer['customer_invoice_email'],
        'customer_extra_text' => $customer['customer_extra_text'],
        'customer_due_date_period' => $customer['customer_due_date_period']
    ]);


    $sql = "INSERT INTO `address` 
            (`id`, `customer_id`, `customer_address_id`, `email`, `firstname`, `lastname`, `postcode`, `street`, `city`, `telephone`, `country_id`, `address_type`, `company`, `country`) VALUES 
            (:id, :customer_id, :customer_address_id, :email, :firstname, :lastname, :postcode, :street, :city, :telephone, :country_id, :address_type, :company, :country) ";
    $stm_insert = $pdo->prepare($sql);
    $stm_insert->execute([
        'id' => $customer['address']['id'],
        'customer_id' => $customer['address']['customer_id'],
        'customer_address_id' => $customer['address']['customer_address_id'],
        'email' => $customer['address']['email'],
        'firstname' => $customer['address']['firstname'],
        'lastname' => $customer['address']['lastname'],
        'postcode' => $customer['address']['postcode'],
        'street' => $customer['address']['street'],
        'city' => $customer['address']['city'],
        'telephone' => $customer['address']['telephone'],
        'country_id' => $customer['address']['country_id'],
        'address_type' => $customer['address']['address_type'],
        'company' => $customer['address']['company'],
        'country' => $customer['address']['country']
    ]);
}