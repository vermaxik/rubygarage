class CreateFollowings < ActiveRecord::Migration
  def change
    create_table :followings, id:false do |t|
      t.integer :my_user_id
      t.integer :following_user_id

      t.timestamps
    end
  end
end
