<h1>GO Visualizer</h1>

Info
-----
GO Visualizer is a tool developed to visualize GO DAG in an interactive way. GO Visualizer is  released under the terms of the GNU Lesser General Public License Ver.2.1. https://www.gnu.org/licenses/old-licenses/lgpl-2.1.en.html

![alt tag](http://kiharalab.org/web/govis.png)

Setup
-----
Make sure the Ruby and Gem is installed, before running GOVisualizer we need to install Sinatra:
```bash
gem install sinatra
```

<br>
Also make sure there is a local setup of mysql and you should import the GO database downloaded from 
<a href="http://archive.geneontology.org/latest-full/">GO Consortium</a>, For example
```bash
wget http://archive.geneontology.org/latest-full/go_monthly-termdb-data.gz
gunzip go_monthly-termdb-data.gz
echo "create database GO_201611" | mysql --user=db_login --password=db_password
mysql --user=db_login --password=db_password GO_201611 < go_monthly-termdb-data
```

 
User can simply run GOVisualizer with following step:

```bash
$ git https://github.com/kiharalab/GOVisualizer.git
$ cd GOVisualizer
$ mv config_template.rb config.rb
```

Now you need to change the setting in config.rb according to your local mysql setting. Then

```bash
$ ruby server.rb
```

Server should be running at http://localhost:4567.
