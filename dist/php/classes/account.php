<?php
class account
{
  public $conn;
  private $errorArray = ['firstName' => [], 'lastName' => [], 'password' => [], 'password2' => [], 'email' => []];
  private $aangemeld = false;

  public static $voornaamMessage = 'Voornaam moet tussen de 2 en 30 letters zijn';
  public static $achternaamMessage = 'Achternaam moet tussen de 2 en 30 letters zijn';
  public static $emailKort = 'email moet minimaal 3 cijfers zijn';
  public static $emailNietGeldig = 'email adres is niet geldig';
  public static $emailGebruikt = 'Er bestaat al een account met dit email adres';
  public static $wachtwoordlengte = 'Achternaam moet tussen de 4 en 50 cijfers zijn';
  public static $loginMislukt = 'login mislukt probeer het opnieuw';
  public static $accountBestaatNiet = 'Sorry dit account bestaat niet';
  public static $wachtwoordincorrect = 'Wrong password';
  public static $passwordDoesntMatch = 'wachtwoord komt niet overheen';
  public static $fieldEmpty = 'this field must be filled to continue';

  //when yu create a new instance of this class please provide an PDO object
  public function __construct($pdo)
  {
    $this->conn = $pdo;
  }

  public function register($firstName, $lastName, $password, $password2, $email, $admin)
  {
    $this->CheckVoornaam($firstName);
    $this->CheckAchternaam($lastName);
    $this->CheckEmail($email);
    $this->checkPassword($password);
    $this->compPassword($password, $password2);

    print_r($this->errorArray);

    if (empty($this->errorArray['firstName']) && empty($this->errorArray['lastName']) && empty($this->errorArray['password']) && empty($this->errorArray['password2']) && empty($this->errorArray['email'])) {
      $this->errorArray = [];
      $this->aangemeld = true;
      return $this->stopInDB($firstName, $lastName, $password, $email, $admin);
    }
    return false;
  }

  public function login($email, $password)
  {
    $user_data = $this->getUser($email);
    if ($user_data) {
      if (password_verify($password, $user_data['password'])) {
        array_push($this->errorArray['password'], account::$wachtwoordincorrect);
        return false;
      }
      return true;
    } else {
      array_push($this->errorArray['password'], account::$accountBestaatNiet);
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

  public function CheckVoornaam($vn)
  {
    if (strlen($vn) < 2 || strlen($vn) > 25) {
      array_push($this->errorArray['firstName'], account::$voornaamMessage);
    }
  }

  public function CheckAchternaam($an)
  {
    if (strlen($an) < 2 || strlen($an) > 30) {
      array_push($this->errorArray['lastName'], account::$achternaamMessage);
    }
  }

  public function CheckEmail($email)
  {
    if (strlen($email) < 3) {
      array_push($this->errorArray['email'], account::$emailKort);
      return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray['email'], account::$emailNietGeldig);
    }
    $query = "SELECT email FROM `user` WHERE email LIKE '%$email%'";
    $stmt = $this->conn->query($query);
    if ($stmt->fetch(PDO::FETCH_ASSOC) != 0) {
      array_push($this->errorArray['email'], account::$emailGebruikt);
    }
  }

  public function checkPassword($password)
  {
    if (strlen($password) < 5 || strlen($password) > 50) {
      array_push($this->errorArray['password'], account::$wachtwoordlengte);
    }
  }

  public function compPassword($password, $password2)
  {
    if ($password !== $password2) {
      array_push($this->errorArray['password2'], account::$passwordDoesntMatch);
    }
  }

  public function getError($type)
  {
    //print_r($this->errorArray[$type]);
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
