import streamlit as st
import requests
import pandas as pd

# URL del microservicio
URL = "http://localhost:8000/analytics/ventas"

# Descargar datos
data = requests.get(URL).json()

st.set_page_config(page_title="Termina Check", layout="centered")
st.title("📊 Dashboard Ventas")
st.metric("Total ventas", data["total"])


df = pd.DataFrame(data["top"])
st.bar_chart(df.set_index("_id"))