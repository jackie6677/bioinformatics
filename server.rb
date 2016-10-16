require 'rubygems'
require 'sinatra'
require 'json'
require 'erb'
require 'mysql'
require_relative 'helpers.rb'
require 'date'

set :public_folder, 'public'
set :bind, '0.0.0.0'

server = 'localhost'
user = 'admin'
pass = ''
curr_db = 'GO_' + Date.today.strftime("%Y%m")
domain = ''
eval File.open('config.rb').read

get "/" do
  response['Access-Control-Allow-Origin'] = domain
  erb :index, :locals => {:go_term => "GO:0008150"}
end

get "/test" do
	response['Access-Control-Allow-Origin'] = domain
    erb :test, :locals => {:go_term => "GO:0008150"}
end

get "/new" do
	response['Access-Control-Allow-Origin'] = domain
    erb :new, :locals => {:go_term => "GO:0008150"}
end

get "/newtree/:job_id/:category" do
	response['Access-Control-Allow-Origin'] = domain
    erb :newtree, :locals => {:job_id => params[:job_id], :category => params[:category]}
end

get "/:go_term" do
  response['Access-Control-Allow-Origin'] = domain
  erb :index, :locals => {:go_term => params[:go_term]}
end

get '/job/:job_id' do
	response['Access-Control-Allow-Origin'] = domain
    erb :job, :locals => {:job_id => params[:job_id]}
end

get '/get_info/:term' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    term = get_info conn, params[:term]
    term.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

get '/get_closest_shared_parent/:term1/:term2' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    parent = get_closest_shared_parent conn, params[:term1], params[:term2]
    parent.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

get '/get_shared_parents/:term1/:term2' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    parents = get_shared_parents conn, params[:term1], params[:term2]
    parents.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

get '/get_parent/:term' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    term = get_parent conn, params[:term]
    term.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

get '/get_count/:term' do
	response['Access-Control-Allow-Origin'] = domain
    content_type :json
    begin
        conn = Mysql.new server, user, pass, curr_db
        term = get_count conn, params[:term]
        term.to_json
        rescue
        {:msg => "Database error. Please contact server administrators."}.to_json
    end
end

get '/get_path/:term' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    term = get_path conn, params[:term]
    term.to_json
  rescue
    {:msg => "Database error."}.to_json
  end
end

get '/get_children/:term' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    children = get_children conn, params[:term]
    children.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

get '/get_path_between_terms/:term1/:term2' do
  response['Access-Control-Allow-Origin'] = domain
  content_type :json
  begin
    conn = Mysql.new server, user, pass, curr_db
    path = get_path_between_terms conn, params[:term1], params[:term2]
    path.to_json
  rescue
    {:msg => "Database error. Please contact server administrators."}.to_json
  end
end

