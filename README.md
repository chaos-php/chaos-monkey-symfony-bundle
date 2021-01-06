# ChaosMonkeySymfonyBundle

Chaos Monkey for Symfony applications

## Assaults

 - **Latency Assault** - adds a delay randomly from the range (min and max)
 - **Exception Assault** - throws given exception class
 - **Memory Assault** - fill memory until target fraction (95% for example) 
 - **Kill Assault** - no mercy, plain `exit()`

## Watchers

 - **Request** - attack http request
 - Repository (not implemented)
 - Service (not implemented)

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
            class: "\RuntimeException"
        kill_app:
            active: false
    watchers: # currently watchers can be enabled/disabled only in container compile time
        request: true
```

## License

ChaosMonkeySymfonyBundle is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Arkadiusz Kondas (@ArkadiuszKondas)
