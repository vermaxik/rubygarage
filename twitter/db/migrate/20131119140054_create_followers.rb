class CreateFollowers < ActiveRecord::Migration
  def change
    create_table :followers, id:false do |t|
      t.integer :my_user_id
      t.integer :follow_user_id

      t.timestamps
    end
  end
end
