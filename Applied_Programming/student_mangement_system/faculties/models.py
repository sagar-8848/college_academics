from django.db import models


class Faculty(models.Model):
    faculty_id = models.AutoField(primary_key=True)
    full_name = models.CharField(max_length=100)
    email = models.EmailField(unique=True)
    department = models.CharField(max_length=100)
    phone = models.CharField(max_length=15)

    class Meta:
        db_table = "faculties"

    def __str__(self):
        return self.full_name