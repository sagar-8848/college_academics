from django import forms

from .models import Subject


class SubjectForm(forms.ModelForm):
    class Meta:
        model = Subject
        fields = ["subject_code", "subject_name", "credit_hours", "course", "faculty"]

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for name, field in self.fields.items():
            field.widget.attrs.setdefault("class", "form-control")
            if name in {"course", "faculty"}:
                field.widget.attrs["class"] = "form-select js-tom-select"
                field.widget.attrs["data-placeholder"] = f"Search and select {name}"
