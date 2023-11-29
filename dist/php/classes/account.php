<?php
class account
{
  public $conn;
  private $errorArray = [];
  private $aangemeld = false;

  public static $voornaamMessage = 'Voornaam moet tussen de 2 en 30 cijfers zijn';
  public static $achternaamMessage = 'Achternaam moet tussen de 2 en 30 cijfers zijn';
  public static $emailKort = 'email moet minimaal 3 cijfers zijn';
  public static $emailNietGeldig = 'email adres is niet geldig';
  public static $emailGebruikt = 'Er bestaat al een account met dit email adres';
  public static $wachtwoordlengte = 'Achternaam moet tussen de 4 en 50 cijfers zijn';
  public static $loginMislukt = 'login mislukt probeer het opnieuw';
  public static $accountBestaatNiet = 'Sorry dit account bestaat niet';
  public static $wachtwoordincorrect = 'Ongeldig wachtwoord';

  //when yu create a new instance of this class please provide an PDO object
  public function __construct($pdo)
  {
    $this->conn = $pdo;
  }

  public function register($fn, $ln, $pw, $em, $admin)
  {
    $this->CheckVoornaam($fn);
    $this->CheckAchternaam($ln);
    $this->CheckEmail($em);
    $this->checkPassword($pw);

    if (empty($this->errorArray)) {
      $this->errorArray = [];
      $this->aangemeld = true;
      return $this->stopInDB($fn, $ln, $pw, $em, $admin);
    }
    return false;
  }

  public function login($em, $ww)
  {
    $user_data = $this->getUser($em);
    if ($user_data) {
      if ($user_data['wachtwoord'] !== $ww) {
        $this->errorArray[] = account::$wachtwoordincorrect;
        return false;
      }
      return true;
    } else {
      $this->errorArray[] = account::$accountBestaatNiet;
      return false;
    }
  }

  public function getUser($em)
  {
    $query = 'SELECT * FROM user WHERE email = :email';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $em);
    $stmt->execute();
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
    return $gebruiker;
  }

  public function stopInDB($fn, $ln, $pw, $em, $admin)
  {
    $query = 'INSERT INTO user (first_name, last_name, password, email, admin) VALUES (?, ?, ?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR);
    $stmt->bindParam(2, $ln, PDO::PARAM_STR);
    $stmt->bindParam(3, $pw, PDO::PARAM_STR);
    $stmt->bindParam(4, $em, PDO::PARAM_STR);
    $stmt->bindParam(5, $admin, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function CheckVoornaam($vn)
  {
    if (strlen($vn) < 2 || strlen($vn) > 25) {
      array_push($this->errorArray, account::$voornaamMessage);
    }
  }

  public function CheckAchternaam($an)
  {
    if (strlen($an) < 2 || strlen($an) > 30) {
      array_push($this->errorArray, account::$achternaamMessage);
    }
  }

  public function CheckEmail($em)
  {
    if (strlen($em) < 3) {
      array_push($this->errorArray, account::$emailKort);
      return;
    }
    if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray, account::$emailNietGeldig);
    }
    $query = "SELECT email FROM `user` WHERE email LIKE '%$em%'";
    $stmt = $this->conn->query($query);
    if ($stmt->fetch(PDO::FETCH_ASSOC) != 0) {
      array_push($this->errorArray, account::$emailGebruikt);
    }
  }

  public function checkPassword($ww)
  {
    if (strlen($ww) < 5 || strlen($ww) > 50) {
      array_push($this->errorArray, account::$wachtwoordlengte);
    }
  }

  public function getError($error)
  {
    if (in_array($error, $this->errorArray)) {
      return "<span class='text-red-600 font-bold text-sm'>$error</span>";
    }
  }
}
?>
