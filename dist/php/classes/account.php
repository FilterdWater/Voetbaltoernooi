<?php
class account
{
  public $conn;
  private $errorArray = ['firstName' => [], 'lastName' => [], 'password' => [], 'password2' => [], 'email' => []];
  private $aangemeld = false;

  public static $loginMislukt = 'login failed try again';
  public static $fieldEmpty = 'this field must be filled to continue';

  //when yu create a new instance of this class please provide an PDO object
  public function __construct($pdo)
  {
    $this->conn = $pdo;
  }

  public function register($firstName, $lastName, $password, $password2, $email, $admin)
  {
    $this->errorArray = ['firstName' => [], 'lastName' => [], 'password' => [], 'password2' => [], 'email' => []];
    $this->CheckVoornaam($firstName);
    $this->CheckAchternaam($lastName);
    $this->CheckEmail($email);
    $query = "SELECT email FROM `user` WHERE email LIKE '%$email%'";
    $stmt = $this->conn->query($query);
    if ($stmt->fetch(PDO::FETCH_ASSOC) != 0) {
      array_push($this->errorArray['email'], 'there already exists an account with this email address');
    }
    $this->checkPassword($password);
    $this->compPassword($password, $password2);

    if (empty($this->errorArray['firstName']) && empty($this->errorArray['lastName']) && empty($this->errorArray['password']) && empty($this->errorArray['password2']) && empty($this->errorArray['email'])) {
      $this->errorArray = [];
      $this->aangemeld = true;
      return $this->stopInDB($firstName, $lastName, $password, $email, $admin);
    }
    return false;
  }

  public function login($email, $password)
  {
    //empty's error array
    $this->errorArray = ['firstName' => [], 'lastName' => [], 'password' => [], 'password2' => [], 'email' => []];
    if ($email == null) {
      array_push($this->errorArray['email'], 'field is empty');
    }
    if ($password == null) {
      array_push($this->errorArray['password'], 'field is empty');
    }

    $this->CheckEmail($email);
    $user_data = $this->getUser($email);

    if (!$user_data) {
      array_push($this->errorArray['email'], 'there doesn\'t exist an account with this email address');
      return false;
    }

    if (password_verify($password, $user_data['password'])) {
      return true;
    } else {
      array_push($this->errorArray['password'], 'password is incorrect');
      return false;
    }
  }

  public function getUser($email)
  {
    $query = 'SELECT * FROM user WHERE email = :email';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
    return $gebruiker;
  }

  public function stopInDB($firstName, $lastName, $password, $email, $admin)
  {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO user (first_name, last_name, password, email, admin) VALUES (?, ?, ?, ?, ?)';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $firstName, PDO::PARAM_STR);
    $stmt->bindParam(2, $lastName, PDO::PARAM_STR);
    $stmt->bindParam(3, $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(4, $email, PDO::PARAM_STR);
    $stmt->bindParam(5, $admin, PDO::PARAM_INT);
    return $stmt->execute();
  }

  private function CheckVoornaam($fn)
  {
    //firstname lenght
    if (strlen($fn) < 1 || strlen($fn) > 29) {
      array_push($this->errorArray['firstName'], 'firstname must be between 2 & 30 characters');
    }
  }

  private function CheckAchternaam($an)
  {
    //lastname lenght
    if (strlen($an) < 1 || strlen($an) > 29) {
      array_push($this->errorArray['lastName'], 'lastname must be between 2 & 30 characters');
    }
  }

  private function CheckEmail($email)
  {
    //email length
    if (strlen($email) < 2) {
      array_push($this->errorArray['email'], 'email moet minimaal 3 cijfers zijn');
    }
    //email Valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray['email'], 'email address is not valid');
    }
    //email exists

    return;
  }

  private function checkPassword($password)
  {
    //password length
    if (strlen($password) < 5 || strlen($password) > 50) {
      array_push($this->errorArray['password'], 'password must be between 4 & 50 characters');
    }
    //password length short
    //password length long (150 characters)
    //password special characters
    //password length
  }

  private function compPassword($password, $password2)
  {
    //password Same
    if ($password !== $password2) {
      array_push($this->errorArray['password2'], 'Passwords do not match.');
    }
  }

  public function getError($type)
  {
    if (isset($this->errorArray[$type])) {
      $errors[] = $this->errorArray[$type]; //pakt de errors van het type
      foreach ($errors[0] as $error) {
        return "<span class='text-red-600 font-bold text-sm'>$error</span>";
      }
    }
    return '';
  }
}
?>
