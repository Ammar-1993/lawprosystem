import re

files = [
    'resources/views/admin/client/client_create.blade.php',
    'resources/views/admin/client/client_edit.blade.php'
]

for filepath in files:
    with open(filepath, 'r') as f:
        content = f.read()
    
    # x_panel -> x_panel lp-card
    content = re.sub(r'class="x_panel"', 'class="x_panel lp-card"', content)
    
    # form-group -> form-group lp-form-group
    content = re.sub(r'(class="[^"]*?\b)form-group(\b[^"]*?")', lambda m: m.group(1) + 'form-group lp-form-group' + m.group(2) if 'lp-form-group' not in m.group(0) else m.group(0), content)
    
    # form-control -> form-control lp-input
    content = re.sub(r'(class="[^"]*?\b)form-control(\b[^"]*?")', lambda m: m.group(1) + 'form-control lp-input' + m.group(2) if 'lp-input' not in m.group(0) else m.group(0), content)
    
    # btn btn-danger -> btn btn-danger lp-btn
    content = re.sub(r'(class="[^"]*?\b)btn-danger(\b[^"]*?")', lambda m: m.group(1) + 'btn-danger lp-btn' + m.group(2) if 'lp-btn' not in m.group(0) else m.group(0), content)
    
    # btn btn-success -> btn btn-success lp-btn lp-btn-primary
    content = re.sub(r'(class="[^"]*?\b)btn-success(\b[^"]*?")', lambda m: m.group(1) + 'btn-success lp-btn lp-btn-primary' + m.group(2) if 'lp-btn-primary' not in m.group(0) else m.group(0), content)

    # also update <button class="btn btn-danger... to have lp-btn if missing (wait, regex above covers it)

    with open(filepath, 'w') as f:
        f.write(content)
