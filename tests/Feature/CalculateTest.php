<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_command_is_existing()
    {
        $this->assertTrue(class_exists(\App\Console\Commands\CalculateCommand::class));
    }

    public function test_can_add_with_proper_arguments()
    {
        $this->artisan('app:calculate', ["num1" => "1", "operand" => "+", "num2" => "2"])
            ->expectsOutput('3')
            ->assertExitCode(0);
    }

    public function test_can_subtract_with_proper_arguments()
    {
        $this->artisan('app:calculate', ["num1" => "5", "operand" => "-", "num2" => "4"])
            ->expectsOutput('1')
            ->assertExitCode(0);
    }

    public function test_can_multiply_with_proper_arguments()
    {
        $this->artisan('app:calculate', ["num1" => "5", "operand" => "*", "num2" => "4"])
            ->expectsOutput('20')
            ->assertExitCode(0);
    }

    public function test_can_divide_with_proper_arguments()
    {
        $this->artisan('app:calculate', ["num1" => "50", "operand" => "/", "num2" => "5"])
            ->expectsOutput('10')
            ->assertExitCode(0);
    }

    public function test_can_square_root_with_proper_arguments()
    {
        $this->artisan('app:calculate', ["num1" => "100", "operand" => "sqrt"])
            ->expectsOutput('10')
            ->assertExitCode(0);
    }

    public function test_cannot_calculate_without_arguments()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate')
            ->assertExitCode(1);
    }

    public function test_cannot_calculate_with_invalid_num1()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate', ["num1" => "x"])
            ->assertExitCode(1);
    }

    public function test_cannot_calculate_with_invalid_operand()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate', ["operand" => "ABC"])
            ->assertExitCode(1);
    }

    public function test_cannot_calculate_with_invalid_num2()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate', ["num2" => "x.3"])
            ->assertExitCode(1);
    }

    public function test_cannot_calculate_with_division_by_zero()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate', ["operand" => "/", "num2" => "0"])
            ->assertExitCode(1);
    }

    public function test_cannot_calculate_sqrt_with_num2()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->artisan('app:calculate', ["operand" => "sqrt", "num2" => "10"])
            ->assertExitCode(1);
    }
}
