from functools import wraps

from django.contrib import messages
# from django.core.exceptions import PermissionDenied
from django.shortcuts import render


def permission_required(permission):

    def decorator(view_func):

        @wraps(view_func)
        def wrapper(request, *args, **kwargs):

            if request.user.has_perm(permission):
                return view_func(request, *args, **kwargs)

            messages.error(
                request,
                "You do not have permission to perform this action."
            )

            return render(
    request,
    "errors/403.html",
    status=403,
)

        return wrapper

    return decorator