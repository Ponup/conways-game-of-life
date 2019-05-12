# PHP-SDL implementation of Conway's game of life

![demo](demo.gif)

# Requirements

- PHP 7
- [SDL bindings for PHP](https://github.com/Ponup/phpsdl)

# Usage

- Use mouse and button to draw cells in the universe
- Use `space` to start simulation
- Use `q` to quit

## Start default blank universe

```sh
$ php main.php
```

## Start from an example universe

```sh
$ php main.php universes/small-exploder.json
```

# References

- [Wikipedia](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life)
