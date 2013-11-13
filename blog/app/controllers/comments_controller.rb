class CommentsController < ApplicationController
  def create
  	@post = Post.find(params[:post_id])
  	#render text: params.inspect
  	params_comment = params.require(:comment).permit(:text);
  	@comment = @post.comments.create(params_comment)
  	@comment.save

  	redirect_to @post
  end

  def destroy
  	@comment = Comment.find(params[:id])
  	@comment.destroy

  	redirect_to @comment.post
  end
end
