class User
  include DataMapper::Resource
  
  property :id, 		Serial
  property :login, 		String, :unique => true
  property :passwd,	 	String
  property :salt,		String
  property :d_create,  	DateTime
  property :visitors,   Integer, :default => 0
end