import re
import sys

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    # Layout wrappers
    content = content.replace('<div class="x_panel">', '<div class="x_panel lp-panel">')
    content = content.replace('class="btn btn-primary"', 'class="btn btn-primary lp-btn lp-btn-primary"')
    
    # Form groups
    content = content.replace('<div class="col-md-12 form-group ">', '<div class="col-md-12 form-group lp-form-group">')
    content = content.replace('<div class="col-md-12 form-group">', '<div class="col-md-12 form-group lp-form-group">')
    
    # Inputs & Selects
    content = content.replace('class="form-control client_id', 'class="form-control lp-input client_id')
    content = content.replace('class="form-control inc_Date"', 'class="form-control lp-input inc_Date"')
    content = content.replace('class="form-control due_Date"', 'class="form-control lp-input due_Date"')
    
    # Table
    content = content.replace('<table class="table tableInv"', '<table class="table lp-table tableInv"')
    
    # Repeater items
    content = content.replace('class="form-control sel services"', 'class="form-control lp-input sel services"')
    content = content.replace('class="form-control" id="description"', 'class="form-control lp-input" id="description"')
    content = content.replace('class="form-control qty"', 'class="form-control lp-input qty"')
    content = content.replace('class="form-control rate"', 'class="form-control lp-input rate"')
    content = content.replace('class="form-control amount"', 'class="form-control lp-input amount"')
    
    # Buttons
    content = content.replace('class="btn btn-danger waves-effect waves-light"', 'class="btn btn-danger lp-btn lp-btn-danger waves-effect waves-light"')
    content = content.replace('class="btn btn-danger waves-effect waves-light btn_remove"', 'class="btn btn-danger lp-btn lp-btn-danger waves-effect waves-light btn_remove"')
    content = content.replace('class="btn btn-success waves-effect waves-light btn btn-success-edit"', 'class="btn btn-success lp-btn lp-btn-primary waves-effect waves-light btn-success-edit"')
    
    # Note textarea
    content = content.replace('class="form-control" id="note"', 'class="form-control lp-input" id="note"')
    
    # Totals
    content = content.replace('class="form-control expence-sub-total"', 'class="form-control lp-input expence-sub-total"')
    content = content.replace('class="form-control expence-sub-total "', 'class="form-control lp-input expence-sub-total"')
    content = content.replace('class="form-control total-width-expence-border "', 'class="form-control lp-input total-width-expence-border"')
    
    # Tax dropdown (handling the weird duplicate class in original)
    content = content.replace('class="tax" name="tax" class="form-control"', 'class="form-control lp-input tax" name="tax"')
    # Another pattern for tax dropdown in edit
    content = content.replace('class="tax" name="tax"\n                                                    class="form-control"', 'class="form-control lp-input tax" name="tax"')
    content = content.replace('class="tax" name="tax"\n                                                    class="form-control"', 'class="form-control lp-input tax" name="tax"')
    
    # Cancel & Save buttons
    content = content.replace('class="btn btn-danger">{{__(\'frontend.cancel\')}}', 'class="btn btn-danger lp-btn lp-btn-danger">{{__(\'frontend.cancel\')}}')
    content = content.replace('class="btn_add_offer btn btn-success"', 'class="btn_add_offer btn btn-success lp-btn lp-btn-primary"')

    with open(filepath, 'w') as f:
        f.write(content)

process_file('resources/views/admin/invoice/invoice_create.blade.php')
process_file('resources/views/admin/invoice/invoice_edit.blade.php')

