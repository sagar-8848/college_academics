from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ("students", "0001_initial"),
    ]

    operations = [
        migrations.AddField(
            model_name="student",
            name="roll_number",
            field=models.CharField(blank=True, max_length=20, null=True, unique=True),
        ),
        migrations.AddField(
            model_name="student",
            name="semester",
            field=models.CharField(blank=True, max_length=50, null=True),
        ),
    ]