class AddColumnInProfile < ActiveRecord::Migration
  def change
  	add_column :profiles, :template, :string
  end
end
