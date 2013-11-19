class AddDefaultValueInTwwiterPost < ActiveRecord::Migration
  def change
  	change_column :twitter_posts, :retwite_id_post, :integer, :default => 0
  	change_column :twitter_posts, :retwite_id_user, :integer, :default => 0
  	change_column :twitter_posts, :reply_id_user, :integer, :default => 0
  	
  end
end
