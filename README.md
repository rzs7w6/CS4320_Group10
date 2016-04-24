SuperIn
==================================================================================================================
## SuperIn Overview

SuperIn is a business-oriented professional social networking service. In SuperIn, you could build your professional identity online and discover the latest professional opportunities.
This repository contains the files used for generating the [SuperIn website](http://superlinkedin.centralus.cloudapp.azure.com/login.html).

The site has already been deployed on  [Azure](https://azure.microsoft.com), a cloud computing platform and infrastructure created by Microsoft for building, deploying, and managing applications and services through a global network of Microsoft-managed datacenters. Every time someone pushes to this repository, the website will be built and updated. For hosting it yourself, see [Setting up a local copy of the website](#setting-up-a-local-copy-of-the-website).

Contributing to the website
---------------------------
To make changes or improvements, fork this repo. Major issues or feature requests should be filed on the issue tracker first, so we can discuss the implications. Pull requests accepted. Feel free to create issue tickets to ask questions about how it works or suggest improvements.

If you want to edit a page, the easiest way is to click the ![Edit page on GitHub](https://cloud.githubusercontent.com/assets/1376924/3712375/a6d7bc42-150f-11e4-9ceb-5230cbbfba3f.png) link under the page title on the website.

This will open the source file on GitHub where you can click the pencil button to start editing:
![Arrow to pencil](https://cloud.githubusercontent.com/assets/1376924/3712474/1d2fe57a-1517-11e4-86b2-d083dbeaa4ae.png)

GitHub's editor shows you both the [Markdown](https://guides.github.com/features/mastering-markdown/) source as well as a preview of the rendered page.
After you've finished your changes, enter a proper summary and description and click the "Propose file change" button to open a pull request.

Setting up a local copy of the website
--------------------------------------
If you want to have a local copy for SuperIn for a larger change, the following instructions will be helpful.

### Dependencies
- Apache2
- php5
- php-pear
- Mysql

Clone this repository:
```
git clone git://github.com/emberjs/website.git
```
Don't forget to [Fork the rep](https://help.github.com/articles/fork-a-repo/) and  [Submit a Pull Request](https://help.github.com/articles/using-pull-requests/)
After you've forked and cloned the repository, the site should now be running locally by double clicking login.html.
