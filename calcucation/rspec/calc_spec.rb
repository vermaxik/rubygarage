require '../calc'

describe 'Calculator'  do
  it 'should exist' do
  	Calc.new
  end

  it 'should have method plus' do
  	Calc.new(2,2).plus
  end


  it 'plus method have two or  more number' do
  	Calc.new(1,2).plus.should eq(3)
  	Calc.new(1,2,3).plus.should_not eq(5)
  	Calc.new(1,2,3).plus.should eq(6)
  end

  it 'plus method have only Fixnum class' do
  	Calc.new(1,1,'one').plus.should eq(2)
  end

  it 'should have method minus' do
  	Calc.new(3,2).minus
  end

  it 'minus method have two or more number' do
  	Calc.new(1,2,3).minus.should eq(-6)
  end

  it 'minus method have only Fixnum class' do
  	Calc.new(2,2,'two').minus.should eq(-4)
  end

  it 'should have method clear' do
  	Calc.new(1,2).clear
  end

  it 'clear method return none array' do
    Calc.new(1,2,3).clear.should eq([])
  end

end