class Hello

	def letter_h 
		@h = [
			[1, 1, 1, 1, 1, 1, 1],
			[0, 0, 0, 1, 0, 0, 0],
			[0, 0, 0, 1, 0, 0, 0],
			[1, 1, 1, 1, 1, 1, 1]
		]
	end

	def letter_e
		@e = [
			[1, 1, 1, 1, 1, 1, 1],
			[1, 0, 0, 1, 0, 0, 1],
			[1, 0, 0, 1, 0, 0, 1],
			[1, 0, 0, 0, 0, 0, 1]
		]
	end

	def letter_l
		@l = [
			[1, 1, 1, 1, 1, 1, 1],
			[0, 0, 0, 0, 0, 0, 1],
			[0, 0, 0, 0, 0, 0, 1],
			[0, 0, 0, 0, 0, 0, 1]
		]
	end

	def letter_o
		@o = [
			[1, 1, 1, 1, 1, 1, 1],
			[1, 0, 0, 0, 0, 0, 1],
			[1, 0, 0, 0, 0, 0, 1],
			[1, 1, 1, 1, 1, 1, 1]
		]
	end

	def letter_r
		@r = [
			[1, 1, 1, 1, 1, 1, 1],
			[1, 0, 0, 1, 0, 0, 0],
			[1, 0, 0, 1, 0, 0, 0],
			[0, 1, 1, 0, 1, 1, 1]
		]
	end

	def letter_u
		@u = [
			[1, 1, 1, 1, 1, 1, 0],
			[0, 0, 0, 0, 0, 0, 1],
			[0, 0, 0, 0, 0, 0, 1],
			[1, 1, 1, 1, 1, 1, 0]
		]
	end

	def letter_b
		@b = [
			[1, 1, 1, 1, 1, 1, 1],
			[1, 0, 0, 1, 0, 0, 1],
			[1, 0, 0, 1, 0, 0, 1],
			[0, 1, 1, 0, 1, 1, 0]
		]
	end


	def letter_y
		@y = [
			[1, 1, 0, 0, 0, 0, 0],
			[0, 0, 1, 0, 0, 0, 0],
			[0, 0, 0, 1, 1, 1, 1],
			[0, 0, 1, 0, 0, 0, 0],
			[1, 1, 0, 0, 0, 0, 0]
		]
	end


end



#puts 'pleas insert your name'
#STDOUT.flush
#name = gets.chomp
#puts 'Your name:' + name

#`git add readme.txt`
#`git commit -m 'Update Readme'`
#`git push git@github.com:vermaxik/rubygarage.git`


h = Hello.new.letter_y
puts h[1][2]


#paperclip
#send_file , x_send_file
#rayane baits
#popen3
