# ChaosMonkeySymfonyBundle

[![Minimum PHP Version](https://img.shields.io/badge/php-%5E8.1-8892BF.svg)](https://php.net/)
![Symfony Versions Supported](https://img.shields.io/badge/symfony-%5E6.4%20%7C%7C%20%5E7.0-green)
[![Packagist Version](https://img.shields.io/packagist/v/chaos-php/chaos-monkey-symfony-bundle)](https://packagist.org/packages/chaos-php/chaos-monkey-symfony-bundle)
[![ci](https://github.com/chaos-php/chaos-monkey-symfony-bundle/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/chaos-php/chaos-monkey-symfony-bundle/actions/workflows/ci.yml)
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

## Activators

 - "Query param" - attack only if given query param is present (default `chaos`)

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
    activators:
       query_param: false # if true then chaos monkey will be called only if given query param exist (with any value)
       query_param_name: 'chaos'
```

## Roadmap
 - [ ] Flex recipe
 - [ ] Metrics (for example `chaos_monkey_request_count_assaulted`)
 - [ ] Assault profiles - each profile can contain different assaults
 - [ ] CustomWatcher (based on container tag)
 - [ ] CustomAssault (not implemented)

## License

ChaosMonkeySymfonyBundle is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Arkadiusz Kondas (@ArkadiuszKondas)
