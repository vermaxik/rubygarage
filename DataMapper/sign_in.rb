require 'rubygems'
require 'sinatra'
require 'data_mapper'
#require 'dm-core'
#require 'dm-sqlite-adapter'
#require 'dm-migrations'


DataMapper.setup(:default, ENV['DATABASE_URL'] || 'sqlite:./db/users.db')
 
load 'model/user.rb'

DataMapper.finalize
#DataMapper.auto_upgrade!
#DataMapper.auto_migrate!

enable :sessions

get "/"  do
  @title = "Main Page"
  if(session['login']) 
    @title = "Wellcom to Main Page"
    @user_name = session['login']
    @user = User.first(:login => @user_name)
    User.all(:login => @user_name).update(:visitors => @user[:visitors]+1 )
    erb :main_page
  else
    redirect '/login'
  end
end

get "/login"  do
  @title = "Login Page"
  erb :login_form
end

get '/login/error' do
  @title = "Login: Error"
  @error = "Check your credential"
  erb :login_form
end

post '/login' do
  unless params[:login].empty? && params[:passwd].empty?
    user = User.first(:login => params[:login])
    if(user)
      require 'digest/md5'
      passwd_with_salt_md5 = Digest::MD5::hexdigest(params[:passwd]+user[:salt].to_s)
      if passwd_with_salt_md5 == user[:passwd]
        
        session['login'] = user[:login]
        User.update(:visitors => user[:visitors]+1 )
        
        redirect '/'
      else
        redirect '/login/error'
      end
    else 
      redirect '/login/error'
    end
  else
    redirect '/login/error'
  end
end

get '/register' do 
  @title = "Sign Up"
  erb :register_form
end

get '/register/error' do 
  @title = "Sign Up: Error"
  @error = "Please input register information"
  erb :register_form
end

post "/register" do
   if !params[:login].empty? && params[:passwd] == params[:passwd_rp] 
      require 'digest/md5'
      salt = Random.new.rand(1..1000)
      passwd_width_salt = params[:passwd] + salt.to_s
      passwd = Digest::MD5::hexdigest(passwd_width_salt)

   	  @user = User.create(:login => params[:login], :passwd => passwd, :salt => salt, :d_create => Time.now)
      redirect '/login'
   else 
   	redirect '/register/error'
   end
end

get "/logout" do
  session['login'].destroy
  redirect "/"
end

not_found do
     status 404
     @title = "404 Page"
     erb :error_404
end