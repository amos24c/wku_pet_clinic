<?php
class Services {
    private $pdo;

    // Constructor to open a database connection
    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database $dbname :" . $e->getMessage());
        }
    }

    // Method to add a new service
    public function addService($name, $description, $price) {
        $sql = "INSERT INTO Services (name, description, price) VALUES (:name, :description, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price]);
        return $this->pdo->lastInsertId(); // Returns the ID of the newly created record
    }

    // Method to get all services
    public function getAllServices() {
        $stmt = $this->pdo->query("SELECT * FROM Services");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a single service by ID
    public function getServiceById($service_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Services WHERE service_id = :service_id");
        $stmt->execute(['service_id' => $service_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a service
    public function updateService($service_id, $name, $description, $price) {
        $sql = "UPDATE Services SET name = :name, description = :description, price = :price WHERE service_id = :service_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'service_id' => $service_id]);
        return $stmt->rowCount();
    }

    // Method to delete a service
    public function deleteService($service_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Services WHERE service_id = :service_id");
        $stmt->execute(['service_id' => $service_id]);
        return $stmt->rowCount();
    }

    // Destructor to close the database connection
    public function __destruct() {
        $this->pdo = null;
    }
}
?>
