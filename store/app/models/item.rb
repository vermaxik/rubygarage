class Item < ActiveRecord::Base
	#attr_accessible :price, :name, :real, :weight,

	validates :price,  numericality: { greater_than: 0, allow_nil: true } 
	validates :name, :description, presence: true

	

	after_initialize { puts "Initialized" } # Item.new; Item.first
	after_save			 { puts "Saved" } # Item.save; Item.create, Item.update_attributes()
	after_create		 { puts "Created" }
	after_update		 { puts "Updated" }
	after_destroy 	 { puts "Destroyed" } # Item.destroy
  
  #has_and_belongs_to_many :carts

  has_many :positions
  has_many :carts, through: :positions

  has_many :comments, as: :commentable

  
end
