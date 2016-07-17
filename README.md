# Symfony 2 Validator Bundle

### Install
```
composer require raducorp/validatorbundle dev-master
```

```
# app/config.yml
# Raducorp master config, setup password validator rules
raducorp:
    validator:
        password:
            options:
                fastfail: true # validator will return false after the first failed rule
            rules:
                - { regex: '^(?:.){5,}$', error: "Password MUST be at least 5 characters long." }
                - { regex: '(?:\d)+', error: "Password MUST have at least 1 digit." }
                - { regex: '^(?!.*(.)\1{2})', error: "Password MUST NOT have 3 repeating characters(%s)." }
                - { regex: '[^0-9a-z]+', error: "Password MUST have at least one upper case or non-alphanumeric character." }
                - { class: 'Raducorp\ValidatorBundle\Rule\CustomRule', error: 'just.another.error' }
```

```
# app/AppKernel.php bundle
new Raducorp\ValidatorBundle\RaducorpValidatorBundle()
```

### Password Validator
```
$validator = $this->getContainer()->get('password.validator');
$result = $validator->validate('mysecretpassword');
```

### Commands
```
# Validate "gs+2Vp=fa"
$ app/console raducorp:password.valdator:validate string gs+2Vp=fa

# Validate password table(id, password, valid)
$ app/console raducorp:password.valdator:validate db
```
