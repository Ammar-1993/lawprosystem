import re

filepath = 'resources/views/admin/client/view/client_detail.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Add lp-card to x_panel
content = re.sub(r'class="x_panel"', 'class="x_panel lp-card"', content)

# Add lp-tabs to the ul
content = re.sub(r'class="nav nav-tabs bar_tabs"', 'class="nav nav-tabs lp-tabs"', content)
content = re.sub(r'class="nav nav-tabs"', 'class="nav nav-tabs lp-tabs"', content) # in case bar_tabs wasn't there

with open(filepath, 'w') as f:
    f.write(content)
