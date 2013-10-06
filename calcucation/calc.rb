class Calc

  attr_accessor :input

  def initialize(*input)
    @array = []
    input.each { |i| @array << i if i.class == Fixnum } 
  end

  def plus
  	@array.inject(0) { |result, element| result += element }
  end
  
  def minus
  	@array.inject(0) { |result, element| result -= element }
  end
  
  def clear
  	@array.clear
  end

end


