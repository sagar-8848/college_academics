from django import forms

from .models import Result


class ResultForm(forms.ModelForm):
    class Meta:
        model = Result
        fields = ["student", "exam", "marks_obtained"]

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.fields["student"].widget.attrs["class"] = "form-select js-tom-select"
        self.fields["student"].widget.attrs["data-placeholder"] = "Search and select student"
        self.fields["exam"].widget.attrs["class"] = "form-select js-tom-select"
        self.fields["exam"].widget.attrs["data-placeholder"] = "Search and select exam"
        self.fields["marks_obtained"].widget.attrs["class"] = "form-control"