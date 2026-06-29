from django import forms
from django.contrib.auth.models import User

from .models import Student


class StudentForm(forms.ModelForm):
    username = forms.CharField(
        max_length=150,
        help_text="Username for student login"
    )

    password = forms.CharField(
        widget=forms.PasswordInput(),
        help_text="Temporary password"
    )

    confirm_password = forms.CharField(
        widget=forms.PasswordInput(),
        label="Confirm Password"
    )

    class Meta:
        model = Student
        fields = [
            "roll_number",
            "semester",
            "full_name",
            "email",
            "phone",
            "address",
            "date_of_birth",
            "gender",
        ]

        widgets = {
            "address": forms.Textarea(attrs={"rows": 3}),
            "date_of_birth": forms.DateInput(attrs={"type": "date"}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)

        for field in self.fields.values():
            field.widget.attrs.setdefault("class", "form-control")

    def clean_username(self):
        username = self.cleaned_data["username"]

        if User.objects.filter(username=username).exists():
            raise forms.ValidationError("Username already exists.")

        return username

    def clean(self):
        cleaned_data = super().clean()

        password = cleaned_data.get("password")
        confirm_password = cleaned_data.get("confirm_password")

        if password and confirm_password and password != confirm_password:
            self.add_error(
                "confirm_password",
                "Passwords do not match."
            )

        return cleaned_data