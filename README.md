# About this Branch

This branch is dedicated to Python scripts that simulate the warehouse assistance programs that the company uses mentioned in the main branch.

The following libraries were used for the development of the mentioned programs:
- **opencv-python** - For image processing and computer vision.
	- **Webcam is required.**
	- In this context it is used to send photos to API.
- **PySimpleGUI** - To create simple graphical user interfaces.
- **requests** - To make HTTP requests.

To interact with Python scripts, you need to execute the following commands:

```bash
# Inside the root folder with scripts (first time)
python -m venv .venv

# When you want to start application
# In Windows
./.venv/Scripts/activate
# In Linux
source ./.venv/bin/activate
pip install -r requirements.txt

python3 cameraWarehouse.py
python3 warehouse.py

# If any script not working try this for linux environment (Optional)
sudo apt install python3-tk
```
