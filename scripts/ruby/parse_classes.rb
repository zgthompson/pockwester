str = File.read('ssu_classes.txt')
match = str.scan(/^(\d{4})\s(\w{2,6})\s(\d{3}\w?)\s(\d{3})\s(?:\*?\w{1,2}\s)?(.*?)\s(\d\.\d)\s([A-Z]{3}).{,4}\s([A-Z]{1,5})\s(\d\d:\d\d\w-\d\d:\d\d\w)\s(\w{1,12})\s(STAFF|\w{1}\s{1,2}\w*?)$/)

File.open('parsed_classes.txt', 'w') do |f|
  match.each { |ssu_class| f.write("'#{ssu_class.join("','")}'".gsub("\n", " ") + "\n") }
end
      
