# ChaosMonkeySymfonyBundle

[![Minimum PHP Version](https://img.shields.io/badge/php-%5E8.1-8892BF.svg)](https://php.net/)
![Symfony Versions Supported](https://img.shields.io/endpoint?url=https%3A%2F%2Fshields.mrgoodbytes.dev%2Fshield%2Fsymfony%2F%255E6.4&logoColor=FFF&style=flat)
[![Latest Stable Version](https://poser.pugx.org/chaos-php/chaos-monkey-symfony-bundle/v/stable?format=flat)](https://packagist.org/packages/chaos-php/chaos-monkey-symfony-bundle)
[![build](https://github.com/chaos-php/chaos-monkey-symfony-bundle/actions/workflows/ci.yml/badge.svg)](https://github.com/chaos-php/chaos-monkey/actions/workflows/build.yml)
![GitHub](https://img.shields.io/github/license/chaos-php/chaos-monkey-symfony-bundle)

Chaos Monkey for Symfony applications. Try to attack your running Symfony App.

## Assaults

 - **Latency Assault** - adds a delay randomly from the range (min and max)
 - **Exception Assault** - throws given exception class
 - **Memory Assault** - fill memory until target fraction (95% for example) 
 - **Kill Assault** - no mercy, plain `exit()`

## Watchers

 - **Request** - attack http request
 - Repository (not implemented)
 - Service (not implemented)

## Symfony 

## How to use

1. Install with composer:
    ```bash
    composer require chaos-php/chaos-monkey-symfony-bundle
    ```
2. Add Symfony bundle (e.g. `config/bundles.php`):
    ```php 
    return [
        //... other bundles
        Chaos\Monkey\Symfony\ChaosMonkeyBundle::class => ['all' => true],
    ];
    ```
3. Add `chaos_monkey.yaml` configuration (copy from below) and enable assaults
4. Watch your app plunge into chaos 🙈🙊🙉 😈

## Configuration reference

```yml
chaos_monkey:
    enabled: false
    probability: 20 # percentage probability of attack (100 - everyone, 0 - none)
    assaults:
        latency:
            active: false
            minimum: 1000 # in miliseconds
            maximum: 3000 # in miliseconds
        memory:
            active: false
            fill_fraction: 0.95 # percentage of memory filling
        exception:
            active: false
            class: 'RuntimeException'
        kill_app:
            active: false
    watchers: # currently watchers can be enabled/disabled only in container compile time
        request:
            enabled: true
            priority: 0
```

## Roadmap
 - [ ] Query param activator
 - [ ] Flex recipe
 - [ ] Metrics (for example `chaos_monkey_request_count_assaulted`)
 - [ ] Assault profiles - each profile can contain different assaults
 - [ ] CustomWatcher (based on container tag)
 - [ ] CustomAssault (not implemented)

## License

ChaosMonkeySymfonyBundle is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Arkadiusz Kondas (@ArkadiuszKondas)
