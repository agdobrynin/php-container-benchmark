# Curious Optimization

Writing these benchmarks I came across an interesting optimization in PHP

A naive benchmark could be written this way:
````injectablephp
assert($container->get('Service') !== null);
````

And that should work, right? Wrong.

Apparently, PHP is capable of optimizing this call away. As a result every Container performed the best in this, only taking 0,010microseconds to complete 1000 iterations of this.

Now let's rewrite this slightly

````injectablephp
$service = $contaier->get('Service');
assert($service !== null);
````

That's close enough, right? Wrong.

Apparently PHP is *not* capable of optimizing this call away and actually performs the benchmark.
