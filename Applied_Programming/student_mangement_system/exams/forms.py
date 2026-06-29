from django import forms

from .models import Exam


class ExamForm(forms.ModelForm):
    class Meta:
        model = Exam
        fields = ["subject", "exam_type", "exam_date", "total_marks"]
        widgets = {
            "exam_date": forms.DateInput(attrs={"type": "date"}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for name, field in self.fields.items():
            field.widget.attrs.setdefault("class", "form-control")
            if name == "subject":
                field.widget.attrs["class"] = "form-select js-tom-select"
                field.widget.attrs["data-placeholder"] = "Search and select subject"
