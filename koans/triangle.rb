# Triangle Project Code.

# Triangle analyzes the lengths of the sides of a triangle
# (represented by a, b and c) and returns the type of triangle.
#
# It returns:
#   :equilateral  if all sides are equal
#   :isosceles    if exactly 2 sides are equal
#   :scalene      if no sides are equal
#
# The tests for this method can be found in
#   about_triangle_project.rb
# and
#   about_triangle_project_2.rb
#
def triangle(a, b, c)
  
  sum = (a + b + c) / 2.0
  result = (sum-a) * (sum-b) * (sum-c)

  if a<=0 || b<=0 || c<=0 || result<=0 then
  	raise TriangleError
  end


  if a == b && b == c   then
  	return  :equilateral
  end
  if ((a == b) || (b==c) || (a == c))  then
  	return :isosceles
  end
  unless a == b && b == c then
  	return :scalene
  end
end

# Error class used in part 2.  No need to change this code.
class TriangleError < StandardError
end
