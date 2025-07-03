Note: CKEditor 4 is currently not supported.

To temporarily add the dependency, you can run:

composer require ckeditor/ckeditor

This will add CKEditor 4 as a Composer dependency while it is still available. However, CKEditor 4 will not work out of the box. A working legacy version has been placed in the common folder instead.

If you wish to use the old version of CKEditor, you may manually replace the current one with the legacy version at your own risk.

Important: After replacing the version, make sure to clear your browser cache, or the old version may not load properly.
