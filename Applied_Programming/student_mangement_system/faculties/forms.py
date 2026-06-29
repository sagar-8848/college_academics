from django import forms

from .models import Faculty


class FacultyForm(forms.ModelForm):
    class Meta:
        model = Faculty
        fields = ["full_name", "email", "department", "phone"]

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for field in self.fields.values():
            field.widget.attrs.setdefault("class", "form-control")
