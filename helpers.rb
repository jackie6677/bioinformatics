# GO Visualizer is  released under the terms of the GNU Lesser General Public License Ver.2.1. 
# https://www.gnu.org/licenses/old-licenses/lgpl-2.1.en.html


# HELPER FUNCTIONS

# database functions
# returns array [name, acc, id] that consists of a term's information
def get_info(conn, term_acc)
  rsp = conn.query "SELECT name, acc, id FROM term where acc=\"#{term_acc}\""
  rsp = rsp.fetch_row
  t_hash = hashify_term rsp
  t_hash[:children] = get_children conn, term_acc
  return t_hash
end

# returns array of arrays [name, acc, id] of the closest parents of a term
def get_parent(conn, term_acc)
    rsp = conn.query "SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
    FROM term2term t2t, term child, graph_path, term ancestor
    WHERE child.id = graph_path.term2_id
    AND ancestor.id = graph_path.term1_id
    AND child.acc =  \"#{term_acc}\"
    AND distance =1
    AND t2t.term1_id = ancestor.id
    AND t2t.term2_id = child.id"
  
  a = []
  rsp.each do |e|
    n = [e[0], e[1], e[2]]
    a.push hashify_term n
  end
  return a
end

# returns term (term name, GO:XXXXXXX)
def get_children(conn, term_acc)
  rsp = conn.query "SELECT name, acc, id FROM term where acc=\"#{term_acc}\""
  rsp = rsp.fetch_row
  term_id = rsp[2]
  # acc field is in form of GO:XXXXXXX and could be used to build URL
  rsp = conn.query "select t.name, t.acc, t.id from term t, term2term t2t where t2t.term1_id=#{term_id} AND t2t.term2_id=t.id"
  a = []
  rsp.each do |e|
    n = [e[0], e[1], e[2]]
    a.push hashify_term n
  end
  return a
end

def get_count(conn,term_acc)
        rsp = conn.query "SELECT term.acc, count(DISTINCT gene_product.id) FROM gene_product LEFT JOIN dbxref ON gene_product.dbxref_id=dbxref.id LEFT JOIN association ON association.gene_product_id=gene_product.id LEFT JOIN term ON association.term_id=term.id WHERE term.acc=\"#{term_acc}\""
        rsp = rsp.fetch_row
        return rsp;
end

# returns term (term name, GO:XXXXXXX)
def get_childrenPath(conn, term_acc)
    rsp = conn.query "SELECT name, acc, id FROM term where acc=\"#{term_acc}\""
    rsp = rsp.fetch_row
    term_id = rsp[2]
    # acc field is in form of GO:XXXXXXX and could be used to build URL
    rsp = conn.query "select t.name, t.acc, t.id from term t, term2term t2t where t2t.term1_id=#{term_id} AND t2t.term2_id=t.id"
    a = []
    rsp.each do |e|
        a.push e[1]
    end
    return a
end

def get_path(conn, term_acc)
  rsp = conn.query "SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
  FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
  AND child.acc=\"#{term_acc}\" AND graph_path.relationship_type_id <= 30 ORDER BY distance DESC"
  h = Hash.new("Parents");
  
	      a = []
	        rsp.each do |e|
                if h[e[1]] == 1
                    next;
                end
               h[e[1]] = 1
               
               c = get_childrenPath conn, e[1]
               buf = conn.query "SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id, relation.name AS relation_name
               FROM term child, graph_path, term ancestor, term relation WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id AND graph_path.relationship_type_id = relation.id
               AND child.acc=\"#{term_acc}\" AND graph_path.relationship_type_id <= 30 ORDER BY distance DESC"
               
               temp = []
               buf.each do |b|
                   $i = 0
                   until $i >= c.length
                       if c[$i].eql? b[1]
                       then
                            buffer = [b[0], b[1], b[4], []]
                            temp.push hashify_4term buffer
                            
                       end
                       $i += 1
                   end
               end
              
                n = [e[0], e[1], e[2],temp]
		        a.push hashify_myterm n

	        end
		return a
end

def get_path_rec(conn, term_acc)
    rsp = conn.query "SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
    FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
    AND child.acc=\"#{term_acc}\" AND graph_path.relationship_type_id =1 ORDER BY distance DESC"
    
    
    a = []
    rsp.each do |e|
        c = get_childrenPath conn, e[1]
        buf = conn.query "SELECT DISTINCT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
        FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
        AND child.acc=\"#{term_acc}\" AND graph_path.relationship_type_id =1 ORDER BY distance DESC"
        
        temp = []
        buf.each do |b|
            $i = 0
            until $i >= c.length
                if c[$i].eql? b[1]
                    then
                    buffer = [b[0],b[1],b[2]]
                    temp.push hashify_term buffer
                    
                end
                $i += 1
            end
        end
        
        n = [e[0], e[1], e[2],temp]
        a.push hashify_myterm n
        
    end
    return a
end

def hashify_myterm(term)
  return {:id => term[1], :name => term[0], :data => {}, :children => term[3]}
end

def hashify_4term(term)
  return {:id => term[1], :name => term[0], :data => term[2], :children => term[3]}
end

# returns list of parent terms (term name, GO:XXXXXXX) that are shared between two nodes
def get_shared_parents(conn, term1_acc, term2_acc)
  rsp = conn.query "SELECT ancestor.name, ancestor.acc, graph_path.term1_id AS ancestor_id
    FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
    AND child.acc=\"#{term1_acc}\""
  parents1 = []
  rsp.each do |r|
    if r[1] != term1_acc and r[0] != 'all' # filter result where query also returns element being compared
      n = [r[0], r[1], r[2]]
      parents1.push n
    end
  end
  
  rsp = conn.query "SELECT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
    FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
    AND child.acc=\"#{term2_acc}\""
  parents2 = []
  rsp.each do |r|
    if r[1] != term2_acc and r[0] != 'all' # filter result where query also returns element being compared
      n = [r[0], r[1], r[2]]
      parents2.push n
    end
  end
  
  shared = []
  parents1.each do |term1|
    parents2.each do |term2|
      if term2[0] == term1[0] and !shared.include? term2
        shared.push term2
      end
    end
  end
  return hashify_terms shared
end

#returns  array [term name, acc, id] of the closest shared parent of two terms
def get_closest_shared_parent(conn, term1_acc, term2_acc)
  rsp = conn.query "SELECT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
    FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
    AND child.acc=\"#{term1_acc}\""
  parents1 = []
  rsp.each do |r|
    if r[1] != term1_acc and r[0] != 'all' # filter result where query also returns element being compared
      n = [r[0], r[1], r[2]]
      parents1.push n
    end
  end
  
  rsp = conn.query "SELECT ancestor.name, ancestor.acc, graph_path.distance, graph_path.term1_id AS ancestor_id
    FROM term child, graph_path, term ancestor WHERE child.id=graph_path.term2_id AND ancestor.id=graph_path.term1_id
    AND child.acc=\"#{term2_acc}\""
  parents2 = []
  rsp.each do |r|
    if r[1] != term2_acc and r[0] != 'all' # filter result where query also returns element being compared
      n = [r[0], r[1], r[2]]
      parents2.push n
    end
  end
  
  shared = []
  parents1.each do |term1|
    parents2.each do |term2|
      if term2[0] == term1[0]
        shared.push term2
      end
    end
  end
  
  closest_shared = nil
  last_val = -1
  x = shared.sort_by do |s|
    if last_val == -1
      closest_shared = s
    elsif last_val > s.last
      closest_shared = s
    end
  end
  
  return hashify_term closest_shared
end

# returns list of terms - each term is an array [term name, acc, id] - that exist between two given nodes
def get_path_between_terms(conn, term1_acc, term2_acc)
  # this just doesn't really work... :( 
  lca = get_closest_shared_parent conn, term1_acc, term2_acc
  puts "LCA"
  p lca
  curr_term = get_info conn, term1_acc
  path1 = []
  while curr_term[:id] != lca[:id]
    path1.push curr_term
    curr_term = get_parent conn, curr_term[:id]
    break
  end
  
  path1.reverse!
  path1.each_cons(2) do |term1, term2|
    term1[:children] = [term2]
  end
  
  puts "---------"
  # TODO: handle multiple parents!!!
  curr_term = get_info conn, term2_acc
  p curr_term
  path2 = []
  while curr_term[:id] != lca[:id]
    path2.push curr_term
    curr_term = get_parent conn, curr_term[:id]
    p curr_term
  end
  
  path2.reverse!  
  path2.each_cons(2) do |term1, term2|
    term1[:children] = [term2]
  end
  path1 = path1[0]
  path2 = path2[0]
  lca[:children] = [path1, path2]
  return lca
end

# utility functions
def hashify_terms(terms)
  a = []
  terms.each do |t|
    h = hashify_term t
    a.push h
  end
  return a
end

def hashify_term(term)
  return {:id => term[1], :name => term[0], :data => {}, :children => []}
end
