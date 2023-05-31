<?php

namespace Core;

class Validator
{
  private $data;
  private $errors = [];

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function validate($rules)
  {
    foreach ($rules as $field => $rule) {
      $rulesList = explode('|', $rule);

      foreach ($rulesList as $singleRule) {
        if (strpos($singleRule, ':') !== false) {
          [$ruleName, $ruleValue] = explode(':', $singleRule, 2);
        } else {
          $ruleName = $singleRule;
          $ruleValue = '';
        }

        $method = 'validate' . ucfirst($ruleName);
        if (method_exists($this, $method)) {
          $this->$method($field, $ruleValue);
        }
      }
    }

    return empty($this->errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }

  private function validateRequired($field)
  {
    if (empty($this->data[$field])) {
      $this->addError($field, 'Ce champ est requis.');
    }
  }

  private function validateEmail($field)
  {
    if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
      $this->addError($field, 'Le champ ' . $field . ' doit être une adresse email valide.');
    }
  }

  private function validateNumeric($field)
  {
    $value = $this->data[$field];
    if (!is_numeric($value)) {
      $this->addError($field, 'Le champ doit être un nombre.');
    }
  }

  private function validateUrl($field)
  {
    $value = $this->data[$field];
    if (!filter_var($value, FILTER_VALIDATE_URL)) {
      $this->addError($field, 'Veuillez entrer une URL valide.');
    }
  }

  private function validateMin($field, $minValue)
  {
    $value = $this->data[$field];
    if ($value < $minValue) {
      $this->addError($field, "Le champ doit être supérieur ou égal à $minValue.");
    }
  }

  private function validateMax($field, $maxValue)
  {
    $value = $this->data[$field];
    if ($value > $maxValue) {
      $this->addError($field, "Le champ doit être inférieur ou égal à $maxValue.");
    }
  }

  private function addError($field, $message)
  {
    $this->errors[$field] = $message;
  }

  private function validateImage($field)
  {
    $file = $this->data[$field];
    if (!$file || !is_array($file) || !isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
      $this->addError($field, 'Aucun fichier n\'a été téléchargé.');
      return;
    }

    $allowedTypes = ['image/jpeg','image/jpg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
      $this->addError($field, 'Veuillez télécharger une image au format JPEG, PNG ou GIF.');
    }
  }


  public function isValidImage($image)
  {

    // Vérifier si le champ est vide
    if ($image['error'] === UPLOAD_ERR_NO_FILE) {
      return "L'image est vide";
    }

    // Vérifier si une erreur s'est produite lors de l'upload
    if ($image['error'] !== UPLOAD_ERR_OK) {
      return "Une erreur s'est produite lors de l'upload"; // 
    }

    // Vérifier le type MIME de l'image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
      return "Le type MIME de l'image n'est pas autorisé"; // 
    }

    // Vérifier l'extension du fichier
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
      return "L'extension du fichier n'est pas autorisée"; // 
    }

    return true; // L'image est valide
  }
}
