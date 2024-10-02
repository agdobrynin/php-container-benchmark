# Container Benchmark

To get straight to the results, follow this [Link](Results.md).

To view the Riaf framework, follow this [Link](https://github.com/L3tum/RiafCore).

## Running the benchmarks yourself

You can run these benchmarks yourself in two ways:

### Docker

In order to run it in a reproducible environment, build and run the docker image with
````shell
docker-compose build --build-arg SERVICES=100
````

Run test "benchmark-table"
```shell
docker-compose run --rm -it php make benchmark-table
```

Run interactive shell
```shell
docker-compose run --rm -it php bash
```

### Local

Requirements:
- ``make``
- ``php >=8.0``

Then simply do a ``make`` and it will automatically prepare and execute all benchmarks.

To only execute the container benchmarks listed in the Results, run ``make prepare`` followed by `make benchmark-table`, 
which will print a nice graph as well.

### Special Cases

As Containers vary a lot, I've built three special case commands to only benchmarks certain kinds of Containers.
These are:
- `make benchmark-compiled` for Compiled Containers
- `make benchmark-match` for Containers making use of `match`
- `make benchmark-containers` to benchmark every Container (may take a long time since some of them are pretty slow)

Each of these can be used with Docker as well, just replace the `benchmark-table` in the command above with the benchmark-* of your choice.

## Contributing

If you want to add your own Container, or found an inconsistency/bug/improvement, then you're more than welcome to make a PR or open an issue.
