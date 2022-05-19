<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\CreatesApplication;
use Psrearick\Containers\Tests\ClearProperties;
use Psrearick\Containers\Tests\TestCase;

//uses(CreatesApplication::class);
//beforeEach()->createApplication();
uses(TestCase::class, RefreshDatabase::class)
//    ->afterEach(function () {
//        app(ClearProperties::class)->after();
//    })
//    ->beforeEach(function () {
//        app(ClearProperties::class)->before();
//    })
    ->in(__DIR__);

//
//uses(\Illuminate\Foundation\Testing\WithFaker::class);

//    ->in(__DIR__);
