from django.db import models
from django.contrib.auth.models import User


class Student(models.Model):
    user = models.OneToOneField(
    User,
    on_delete=models.CASCADE,
    null=True,
    blank=True,
    related_name="student_profile")
    student_id = models.AutoField(primary_key=True)
    roll_number = models.CharField(max_length=20, unique=True, blank=True, null=True)
    semester = models.CharField(max_length=50, blank=True, null=True)
    full_name = models.CharField(max_length=100)
    email = models.EmailField(unique=True)
    phone = models.CharField(max_length=15, blank=True, null=True)
    address = models.TextField(blank=True, null=True)
    date_of_birth = models.DateField(blank=True, null=True)
    gender = models.CharField(max_length=10, blank=True, null=True)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "students"

    def __str__(self):
        if self.roll_number:
            return f"{self.full_name} ({self.roll_number})"
        return self.full_name