class CreateProfiles < ActiveRecord::Migration
  def up
    create_table :profiles do |t|
    	t.string :facebook
    	t.string :vkontakte
    	t.string :linkedin 
    	t.timestamps
    end
  end

  def down
  	drop_table :profiles
  end

end
