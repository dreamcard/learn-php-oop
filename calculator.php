<?php

/**
 * The calculation contract
 */
interface IOperator {
	public function make(array $operands);
}

/**
 *  The concretes for contracts
 */

// Add
class AddOperator implements IOperator {

	public function make(array $operands)
	{
		return array_sum($operands);
	}
}

// Subtract
class SubtractOperator implements IOperator {

	public function make(array $operands)
	{
		return $operands[0] - $operands[1];
	}
}

// Multiply
class MultiplyOperator implements IOperator {

	public function make(array $operands)
	{
		return $operands[0] * $operands[1];
	}
}

// Divide
class DivideOperator implements IOperator {

	public function make(array $operands)
	{
		if($operands[1] == 0) {
			return "[Error] division by zero!";
		}
		return $operands[0] / $operands[1];
	}
}

/**
 * The calculator for real 
 */
class Calculator {

	protected $operands;

	public function setOperands(array $operands)
	{
		if(count($operands) != 2) {
			return "[Error] must be two operands provided";
		}

		$this->operands = $operands;
		return true;
	}

	public function calculate(IOperator $operator)
	{
		return $operator->make($this->operands);
	}
}

/**
 * The output format printer
 */
class Printer {

	public function show($result)
	{
		echo "The final result is: " . $result . "\n";
	}
}

/**
 * The main program execution here
 */
class Program {

	protected $calculator;
	protected $printer;

	public function __construct(Calculator $calculator, Printer $printer)
	{
		$this->calculator = $calculator;
		$this->printer = $printer;
	}

	public function run(array $operands, IOperator $operator)
	{
		if($this->calculator->setOperands($operands)) {
			$this->printer->show($this->calculator->calculate($operator));
		}
	}
}
/******************
 * ENTRY PROGRAM
 ******************/
$program = new Program(new Calculator, new Printer);
$program->run(array(2, 6), new AddOperator);
$program->run(array(1, 3), new SubtractOperator);
$program->run(array(5, 2), new MultiplyOperator);
$program->run(array(6, 3), new DivideOperator);
$program->run(array(6, 0), new DivideOperator);


