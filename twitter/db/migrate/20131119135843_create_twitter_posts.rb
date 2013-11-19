class CreateTwitterPosts < ActiveRecord::Migration
  def change
    create_table :twitter_posts do |t|
      t.integer :user_id
      t.text :post
      t.integer :retwite_id_post
      t.integer :retwite_id_user
      t.integer :reply_id_user

      t.timestamps
    end
  end
end
