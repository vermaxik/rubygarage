class AddDescritpionColumItems < ActiveRecord::Migration
  def change
  	add_column :items, :descriptions, :string
  end
end