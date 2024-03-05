<?php
loadModel('User');

class Login extends Model {

    //TO-DO Implementar Regex para email valido
    public function validate() {
        $errors = [];

        if(!$this->email) {
            $errors['email'] = 'E-mail é um campo obrigatório.';
        }

        if(!$this->email) {
            $errors['password'] = 'Por favor, Informe a senha.';
        }

        if(count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    public function checkLogin() {
        $this->validate();
        
        $user = User::getOne(['email' => $this->email]);
        
        if($user->end_date) {
            throw new AppException('Usuário está desligado da empresa');
        }

        if($user) {
            if(password_verify($this->password, $user->password)) {
                return $user;
            }
        }

        throw new AppException('Usuário e Senha inválidos.');
    }
}