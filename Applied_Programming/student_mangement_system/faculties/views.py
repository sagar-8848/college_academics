from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from .forms import FacultyForm
from .models import Faculty
from django.contrib.auth.decorators import login_required
from accounts.decorators import permission_required

@login_required
@permission_required("faculties.view_faculty")
def faculty_list(request):
	search_query = request.GET.get("search", "")
	faculties = Faculty.objects.all()

	if search_query:
		faculties = faculties.filter(
			Q(full_name__icontains=search_query)
			| Q(email__icontains=search_query)
			| Q(department__icontains=search_query)
		)

	paginator = Paginator(faculties, 10)
	page_number = request.GET.get("page")
	page_obj = paginator.get_page(page_number)

	return render(
		request,
		"faculties/faculty_list.html",
		{
			"faculties": page_obj,
			"page_obj": page_obj,
			"search_query": search_query,
		},
	)

@login_required
@permission_required("faculties.add_faculty")
def add_faculty(request):
	form = FacultyForm(request.POST or None)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Faculty added successfully!")
		return redirect("faculty_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Add Faculty",
			"submit_label": "Save Faculty",
			"cancel_url": "/faculties/",
		},
	)

@login_required
@permission_required("faculties.change_faculty")
def edit_faculty(request, faculty_id):
	faculty = get_object_or_404(Faculty, faculty_id=faculty_id)
	form = FacultyForm(request.POST or None, instance=faculty)

	if request.method == "POST" and form.is_valid():
		form.save()
		messages.success(request, "Faculty updated successfully!")
		return redirect("faculty_list")

	return render(
		request,
		"shared/form.html",
		{
			"form": form,
			"form_title": "Edit Faculty",
			"submit_label": "Update Faculty",
			"cancel_url": "/faculties/",
		},
	)

@login_required
@permission_required("faculties.delete_faculty")
def delete_faculty(request, faculty_id):
	faculty = get_object_or_404(Faculty, faculty_id=faculty_id)

	if request.method == "POST":
		faculty.delete()
		messages.success(request, "Faculty deleted successfully!")
		return redirect("faculty_list")

	return render(
		request,
		"shared/confirm_delete.html",
		{
			"title": "Delete Faculty",
			"message": f"Are you sure you want to delete {faculty.full_name}?",
			"confirm_label": "Delete Faculty",
			"cancel_url": "/faculties/",
		},
	)
