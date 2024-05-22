<?php

namespace App\Console\Commands;

use App\Rules\Num2Checker;
use Illuminate\Console\Command;
use Validator;
use Exception;

class CalculateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate {num1} {operand} {num2?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do simple calculations (addition, subtraction, multiplication, division, square root)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $arguments = $this->validateArguments();

            $num1 = $this->argument('num1');
            $operand = $this->argument('operand');
            $num2 = $this->argument('num2');
    
            $results = $this->compute($num1, $operand, $num2);
            
            if(is_null($results)) {
                throw new \Exception("Calculation Failure!");
            }
    
            $this->info($results);

            return 0;
        } catch(\Exception $e) {
            $this->error($e);
            return 1;
        }
        
    }

    private function validateArguments(): ?array
    {
        $validator = Validator::make($this->arguments(), [
            'num1' => ['required', 'numeric'],
            'operand' => ['required', 'in:+,-,*,/,sqrt'],
            'num2'  => ['required_if:operand,+,-,*,/', new Num2Checker($this->argument('operand'))]
        ]);
 
        if ($validator->fails()) {
            $this->error('An error occurred. The given attributes are invalid: ');
 
            collect($validator->errors()->all())
                ->each(fn ($error) => $this->error($error));
            exit;
        }
 
        return $validator->validated();
    }

    private function compute($num1, $operand, $num2 = null)
    {
        $results = null;
        switch($operand) {
            case '+':
                $results = $num1 + $num2;
                break;
            case '-':
                $results = $num1 - $num2;
                break;
            case '*':
                $results = $num1 * $num2;
                break;
            case '/':
                $results = $num1 / $num2;
                break;
            case 'sqrt':
                $results = sqrt($num1);
                break;
        }

        return $results;
    }
}
