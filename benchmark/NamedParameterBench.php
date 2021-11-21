<?php

namespace Benchmark;

use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Groups;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use Project\Generated\Service0;
use Project\Generated\Service1;

#[Revs(100000)]
#[Iterations(100)]
#[Groups(["Misc"])]
class NamedParameterBench
{
    /**
     *
     * +---------------------+-------------------------------------------+--------+-----+-----------+---------+---------+
     * | benchmark           | subject                                   | revs   | its | mem_peak  | mode    | rstdev  |
     * +---------------------+-------------------------------------------+--------+-----+-----------+---------+---------+
     * | NamedParameterBench | benchInstantiateService                   | 100000 | 100 | 941.280kb | 0.058μs | ±18.28% |
     * | NamedParameterBench | benchInstantiateServiceWithNamedParameter | 100000 | 100 | 941.472kb | 0.062μs | ±7.98%  |
     * | NamedParameterBench | benchInstantiateWithNullable              | 100000 | 100 | 941.328kb | 0.067μs | ±1.41%  |
     * | NamedParameterBench | benchInstantiateWithNullableParentheses   | 100000 | 100 | 941.376kb | 0.067μs | ±1.44%  |
     * +---------------------+-------------------------------------------+--------+-----+-----------+---------+---------+
     *
     */

    private Service0 $service;

    private mixed $null;

    private mixed $store;

    public function setUp(): void
    {
        $this->service = new Service0();
        $this->null = null;
    }

    #[BeforeMethods("setUp")]
    public function benchInstantiateService(): object
    {
        return new Service1($this->service);
    }

    #[BeforeMethods("setUp")]
    public function benchInstantiateServiceWithNamedParameter(): object
    {
        return new Service1(service: $this->service);
    }

    #[BeforeMethods("setUp")]
    public function benchInstantiateWithNullable(): object
    {
        return new Service1($this->null ?? $this->store = $this->service);
    }

    #[BeforeMethods("setUp")]
    public function benchInstantiateWithNullableParentheses(): object
    {
        return new Service1($this->null ?? ($this->store = $this->service));
    }
}
