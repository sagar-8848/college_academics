from django import forms

from .models import Enrollment


class EnrollmentForm(forms.ModelForm):
    class Meta:
        model = Enrollment
        fields = ["student", "subject"]

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.fields["student"].widget.attrs["class"] = "form-select js-tom-select"
        self.fields["student"].widget.attrs["data-placeholder"] = "Search and select student"
        self.fields["subject"].widget.attrs["class"] = "form-select js-tom-select"
        self.fields["subject"].widget.attrs["data-placeholder"] = "Search and select subject"
