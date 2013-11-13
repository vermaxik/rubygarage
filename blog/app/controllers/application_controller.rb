class ApplicationController < ActionController::Base

	def check_if_admin
		render text: "Access denied", status: 403  unless params[:admin]
	end

  # Prevent CSRF attacks by raising an exception.
  # For APIs, you may want to use :null_session instead.
  protect_from_forgery with: :exception
end
